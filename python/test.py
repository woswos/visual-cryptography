#!/usr/bin/python3
import sys
import secrets
import PIL as pillow
import PIL.Image
import PIL.ImageEnhance
import numpy as np
import json
import svgwrite

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


def drawImage(dist):
    total_p = 0.0
    for prob, _ in dist:
        assert prob > -0.0001 and prob < 1.0001
        total_p += prob
    assert total_p > -0.0001 and total_p < 1.0001

    r = randfloat()

    for prob, outcome in dist:
        if r < prob:
            return outcome
        r -= prob

    return dist[-1][1]

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


def noise3in3out(img1, img2, img3):
    shape = img1.shape
    if shape != img2.shape or shape != img3.shape:
        raise TypeError('all three images must have the same shape')

    out1 = np.zeros(shape, dtype=np.uint8)
    out2 = np.zeros(shape, dtype=np.uint8)
    out3 = np.zeros(shape, dtype=np.uint8)

    # Scale the images into range
    contrast = 1/6
    img1 = img1 * contrast
    img2 = img2 * contrast
    img3 = img3 * contrast

    for i in range(shape[0]):
        for j in range(shape[1]):
            temp1 = img1[i,j]
            temp2 = img2[i,j]
            temp3 = img3[i,j]

            o1, o2, o3 = drawImage([
                (0, (1,1,1)),
                (temp1 + temp2 + temp3, (0,0,0)),
                (temp3, (0,1,1)),
                (temp2, (1,0,1)),
                (temp1, (1,1,0)),
                (1/3 - temp1 - temp2, (1,0,0)),
                (1/3 - temp1 - temp3, (0,1,0)),
                (1/3 - temp2 - temp3, (0,0,1))
            ])

            out1[i,j] = o1 * 255
            out2[i,j] = o2 * 255
            out3[i,j] = o3 * 255

    return (out1, out2, out3)


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

    return (out1, out2)


def convertToSVG(inputFile, outputFile, shape, transparency, pixelSize, pixelSamplingFreq):
    image = loadImage(inputFile)
    dwg = svgwrite.Drawing(filename = str(outputFile), profile='tiny')

    pixelSize = int(pixelSize)
    # You may skip some pixels
    pixelSamplingFreq = int(pixelSamplingFreq)

    if(shape == "rectangle"):
        for yPixel in range(0, image.shape[0], pixelSamplingFreq):
            for xPixel in range(0, image.shape[1], pixelSamplingFreq):
                pixelColor = image[yPixel][xPixel]
                if(str(transparency) == "false"):
                    if(pixelColor < 0.5):
                        dwg.add(dwg.rect((xPixel, yPixel), (pixelSize, pixelSize), fill='black'))
                    else:
                        dwg.add(dwg.rect((xPixel, yPixel), (pixelSize, pixelSize), fill='white'))
                else:
                    if(pixelColor < 0.5):
                        dwg.add(dwg.rect((xPixel, yPixel), (pixelSize, pixelSize), fill='black'))

    if(shape == "circle"):
        for yPixel in range(0, image.shape[0], pixelSamplingFreq):
            for xPixel in range(0, image.shape[1], pixelSamplingFreq):
                pixelColor = image[yPixel][xPixel]
                if(str(transparency) == "false"):
                    if(pixelColor < 0.5):
                        dwg.add(dwg.circle((xPixel, yPixel), pixelSize, fill='black'))
                    else:
                        dwg.add(dwg.circle((xPixel, yPixel), pixelSize, fill='white'))
                else:
                    if(pixelColor < 0.5):
                        dwg.add(dwg.circle((xPixel, yPixel), pixelSize, fill='black'))

    if(shape == "triangle"):
        flip = False
        for yPixel in range(0, image.shape[0], pixelSamplingFreq):
            for xPixel in range(0, image.shape[1], pixelSamplingFreq):
                pixelColor = image[yPixel][xPixel]
                print(pixelColor)
                if(str(transparency) == "false"):
                    if(flip):
                        if(pixelColor < 0.5):
                            dwg.add(dwg.polygon([(xPixel,yPixel), ((xPixel+pixelSize), (yPixel+pixelSize)), ((xPixel+(pixelSize*2)),yPixel)]))
                            flip = False
                    else:
                        if(pixelColor < 0.5):
                            dwg.add(dwg.polygon([(xPixel,yPixel+pixelSize), (xPixel+pixelSize,yPixel), ((xPixel+(pixelSize*2)),(yPixel+pixelSize))]))
                            flip = True
                else:
                    if(flip):
                        if(pixelColor < 0.5):
                            dwg.add(dwg.polygon([(xPixel,yPixel), ((xPixel+pixelSize), (yPixel+pixelSize)), ((xPixel+(pixelSize*2)),yPixel)]))
                            flip = False
                    else:
                        if(pixelColor < 0.5):
                            dwg.add(dwg.polygon([(xPixel,yPixel+pixelSize), (xPixel+pixelSize,yPixel), ((xPixel+(pixelSize*2)),(yPixel+pixelSize))]))
                            flip = True

    dwg.save()


if __name__ == '__main__':
    selectedAlgorithm = sys.argv[1]
    inputFiles = sys.argv[2]
    vector = sys.argv[3]

    # Parse files
    inputFilesParsed = json.loads(inputFiles)
    vectorParsed = json.loads(vector)

    print("Selected algorithm: ", selectedAlgorithm)
    print("Given input file(s): ", inputFiles)
    print("Vectorize: ", vectorParsed["vector"])
    if(vectorParsed["vector"] == "true"):
        print("Vector Type: ", vectorParsed["type"])
        print("Vector Transparent: ", vectorParsed["transparent"])
        print("Vector pixel size: ", vectorParsed["pixelSize"])
        print("Vector pixel sampling frequency: ", vectorParsed["samplingFrequency"])

    print("")
    # Apply encryption algorithms
    if ((selectedAlgorithm == "noise1in2out") or (selectedAlgorithm == "0")):
        print("Processing...")
        image = loadImage(inputFilesParsed["0"])
        outputImages = noise1in2out(image)

    elif((selectedAlgorithm == "steganography3in2out") or (selectedAlgorithm == "1")):
        print("Processing...")
        clear1 = loadImage(inputFilesParsed["0"])
        clear2 = loadImage(inputFilesParsed["1"])
        secret = loadImage(inputFilesParsed["2"])
        outputImages = steganography3in2out(clear1, clear2, secret)

    elif((selectedAlgorithm == "noise3in3out") or (selectedAlgorithm == "2")):
        print("Processing...")
        image1 = loadImage(inputFilesParsed["0"])
        image2 = loadImage(inputFilesParsed["1"])
        image3 = loadImage(inputFilesParsed["2"])
        outputImages = noise3in3out(image1, image2, image3)

    print("Output file(s): ")
    directory = "result/"
    for i in range(0, len(outputImages)):
        fileName = directory + str(i) + ".png"
        saveImage(outputImages[i], fileName)
        print(fileName)

    # Decide to convert to vector or not
    if (vectorParsed["vector"] == "true"):
        print("")
        print("Converting to vector...")
        print("Might take a while...")
        for i in range(0, len(outputImages)):
            inputFile = directory + str(i) + ".png"
            outputFile = directory + str(i) + ".svg"
            convertToSVG(inputFile, outputFile, vectorParsed["type"], vectorParsed["transparent"], vectorParsed["pixelSize"], vectorParsed["samplingFrequency"])

        print("Converted images to SVG")
