#!/usr/bin/python3
import sys
import secrets
import PIL as pillow
import PIL.Image
import PIL.ImageEnhance
import numpy as np
import json
import svgwrite
import svgutils.transform as sg
from svgutils.compose import *
import random
import traceback

def main():
    try:
        inputFiles = sys.argv[1]
        inputFilesParsed = json.loads(inputFiles)
        print("Selected algorithm: ", inputFilesParsed["algorithm"])
        print("Given input file(s): ", inputFiles)
    except:
        print("Please specify options")

    try:
        vector = sys.argv[2]
        vectorParsed = json.loads(vector)
        print("")
        print("Vectorize: ", vectorParsed["vector"])
        if(vectorParsed["vector"] == "true"):
            print("Vector Type: ", vectorParsed["type"])
            print("Vector Transparent: ", vectorParsed["transparent"])
            print("Vector pixel size: ", vectorParsed["pixelSize"])
            print("Vector pixel sampling frequency: ", vectorParsed["samplingFrequency"])
    except:
        pass

    print("")

    # Apply encryption algorithms
    if ((inputFilesParsed["algorithm"] == "noise1in2out") or (inputFilesParsed["algorithm"] == "0")):
        print("Processing...")
        image = loadImage(inputFilesParsed["img0"], inputFilesParsed["brightness"], inputFilesParsed["contrast"])
        outputImages = noise1in2out(image)

    elif((inputFilesParsed["algorithm"] == "steganography3in2out") or (inputFilesParsed["algorithm"] == "1")):
        print("Processing...")
        clear1 = loadImage(inputFilesParsed["img0"], inputFilesParsed["brightness"], inputFilesParsed["contrast"])
        clear2 = loadImage(inputFilesParsed["img1"], inputFilesParsed["brightness"], inputFilesParsed["contrast"])
        secret = loadImage(inputFilesParsed["img2"], inputFilesParsed["brightness"], inputFilesParsed["contrast"])
        outputImages = steganography3in2out(clear1, clear2, secret)

    elif((inputFilesParsed["algorithm"] == "noise3in3out") or (inputFilesParsed["algorithm"] == "2")):
        print("Processing...")
        image1 = loadImage(inputFilesParsed["img0"], inputFilesParsed["brightness"], inputFilesParsed["contrast"])
        image2 = loadImage(inputFilesParsed["img1"], inputFilesParsed["brightness"], inputFilesParsed["contrast"])
        image3 = loadImage(inputFilesParsed["img2"], inputFilesParsed["brightness"], inputFilesParsed["contrast"])
        outputImages = noise3in3out(image1, image2, image3)

    print("Output file(s): ")
    directory = "result/"
    for i in range(0, len(outputImages)):
        fileName = directory + str(i) + ".png"
        saveImage(outputImages[i], fileName)
        print(fileName)


    try:
        # Decide to convert to vector or not
        if (vectorParsed["vector"] == "true"):
            print("")
            print("Converting to vector...")
            print("Might take a while...")
            for i in range(0, len(outputImages)):
                inputFile = directory + str(i) + ".png"
                outputFile = directory + str(i) + ".svg"

                try:
                    vectorParsed["customFile"]
                except:
                    # Adding a new key value pair
                    vectorParsed.update( {"customFile" : "none"})

                try:
                    convertToSVG(inputFile, outputFile, vectorParsed["type"], vectorParsed["transparent"], vectorParsed["pixelSize"], vectorParsed["samplingFrequency"], vectorParsed["customFile"])
                except Exception:
                    traceback.print_exc()

            print("Converted images to SVG")
    except:
        pass

def randfloat():
    return secrets.randbits(32) / (1 << 32)


def loadImage(fileName, brightness = 1, contrast = 1):
    image = PIL.Image.open(fileName).convert('L')

    if(float(brightness) < 1):
        image = PIL.ImageEnhance.Brightness(image).enhance(float(brightness))

    if(float(contrast) < 1):
        image = PIL.ImageEnhance.Contrast(image).enhance(float(contrast))

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


def convertToSVG(inputFile, outputFile, shape, transparency, pixelSize, pixelSamplingFreq, customFile = "none"):
    image = loadImage(inputFile)
    # You may skip some pixels
    pixelSamplingFreq = int(pixelSamplingFreq)

    if(shape == "custom"):
        print("Using custom shape for " + str(outputFile))

        # Create an empty output file first
        dwg = svgwrite.Drawing(filename = str(outputFile), profile='tiny')
        dwg.save()

        # Load files
        template = sg.fromfile(str(outputFile))

        try:
            test = sg.fromfile(str(customFile))
            testRoot = test.getroot()
            noBlack = False
        except:
            noBlack = True
            pass

        #create new SVG figure
        template = sg.SVGFigure()

        for yPixel in range(0, image.shape[0], pixelSamplingFreq):
            for xPixel in range(0, image.shape[1], pixelSamplingFreq):
                pixelColor = image[yPixel][xPixel]
                if(pixelColor < 0.5):
                    #template.append(black)
                    black = sg.fromfile(str(customFile))
                    blackRoot = black.getroot()
                    #blackRoot.rotate(random.randint(0, 360))
                    #blackRoot.moveto(int(yPixel+random.randint(-1,1)), int(xPixel+random.randint(-1,1)), scale=float(pixelSize))
                    blackRoot.moveto(yPixel, xPixel, scale=float(pixelSize))
                    template.append([blackRoot])

        template.save(str(outputFile))

    else:
        dwg = svgwrite.Drawing(filename = str(outputFile), profile='tiny')
        pixelSize = int(pixelSize)

        if(shape == "rectangle"):
            print("Using rectangles for " + str(outputFile))
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
            print("Using circles for " + str(outputFile))
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
            print("Using triangles for " + str(outputFile))
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
    main()
