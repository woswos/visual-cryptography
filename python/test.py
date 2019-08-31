#!/usr/bin/python3
import sys
import secrets
import PIL as pillow
import PIL.Image
import PIL.ImageEnhance
import numpy as np
import json

# pyinstaller test.py --onefile && ./dist/test arg1 arg2
#   arg1 -> algorithm selection
#   arg2 -> input file (absolute path)

#print ("This is the name of the script: ", sys.argv[0])
#print ("Number of arguments: ", len(sys.argv))
#print ("The arguments are: " , str(sys.argv))


def randfloat():
    return secrets.randbits(32) / (1 << 32)


def loadImage(fileName):
    image = PIL.Image.open(fileName).convert('L')
    #image = PIL.ImageEnhance.Brightness(image).enhance(float(brightness))
    #image = PIL.ImageEnhance.Contrast(image).enhance(float(contrast))
    imageArray = np.array(image)
    imageArray = imageArray.astype(float) / 255
    return imageArray


def saveImage(img, fileName):
    PIL.Image.fromarray(img).save(fileName)
    print("Saved output file: ", fileName)


def noise1in2out(img):
    shape = img.shape

    out1 = np.zeros(shape, dtype=np.uint8)
    out2 = np.zeros(shape, dtype=np.uint8)

    for i in range(shape[0]):
        for j in range(shape[1]):
            o1 = secrets.randbits(1)
            if randfloat() < img[i, j]:
                o2 = o1
            else:
                o2 = 1 - o1

            out1[i, j] = o1 * 255
            out2[i, j] = o2 * 255

    return (out1, out2)


def steganography3in2out(clear1, clear2, secret):
    shape = clear1.shape
    if shape != clear2.shape or shape != secret.shape:
        raise TypeError('all three images must have the same shape')

    out1 = np.zeros(shape, dtype=np.uint8)
    out2 = np.zeros(shape, dtype=np.uint8)

    # Scale the images into range
    contrast = 0.25
    secret = secret * contrast
    clear1 = clear1 * (0.5 - contrast) + contrast
    clear2 = clear2 * (0.5 - contrast) + contrast

    for i in range(shape[0]):
        for j in range(shape[1]):
            x = secret[i, j]
            a = clear1[i, j]
            b = clear2[i, j]
            p11 = x
            p01 = b-x
            p10 = a-x
            p00 = 1 - p11 - p01 - p10
            assert p00 > -0.0001 and p00 < 1.0001

            r = randfloat()
            if r < p00:
                o1, o2 = 0, 0
            elif r - p00 < p01:
                o1, o2 = 0, 1
            elif r - p00 - p01 < p10:
                o1, o2 = 1, 0
            else:
                o1, o2 = 1, 1

            out1[i, j] = o1 * 255
            out2[i, j] = o2 * 255

            # Propagate the errors using the Floyd-Steinberg kernel
            # def prop(mat, di, dj, err):
            #    if i+di < mat.shape[0] and 0 <= j+dj < mat.shape[1]:
            #        mat[i+di][j+dj] += 0.25*err

            #prop(clear1, 0,  1, (a-o1) * (7/16))
            #prop(clear1, 1, -1, (a-o1) * (3/16))
            #prop(clear1, 1,  0, (a-o1) * (5/16))
            #prop(clear1, 1,  1, (a-o1) * (1/16))

    return (out1, out2)


if __name__ == '__main__':
    selectedAlgorithm = sys.argv[1]
    inputFiles = sys.argv[2]

    print("Selected algorithm: ", selectedAlgorithm)
    print("Given input file(s): ", inputFiles)

    inputFilesParsed = json.loads(inputFiles)

    if(selectedAlgorithm == "noise1in2out"):
	    image = loadImage(inputFilesParsed["0"])
        outputImages = noise1in2out(image)
        saveImage(outputImages[0], "1.png")
        saveImage(outputImages[1], "2.png")

	elif(selectedAlgorithm == "steganography3in2out"):
        outputImages = steganography3in2out(image)
        saveImage(outputImages[0], "1.png")
        saveImage(outputImages[1], "2.png")

# print "default_5.png;default_6.png;"
