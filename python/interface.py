#!/usr/bin/python3
import os
import json

def main():
    #checkLibraries()
    #compileCode()

    while True:
        try:
            selectedAlgorithim = input("Select an algorithm. Options:  noise1in2out, noise3in3out, steganography3in2out \n")
            if((selectedAlgorithim != "noise1in2out") and (selectedAlgorithim != "noise3in3out") and (selectedAlgorithim != "steganography3in2out")):
                raise ValueError()

        except ValueError:
            print("Please enter a valid value")

            continue
        else:
            print("")
            break

    print("Please enter the names of images that will be processed, including the extensions. Like photo.png")
    print('Use " " if the image name has multiple words. For example, "my photo.png"')
    if(selectedAlgorithim == "noise1in2out"):
        img0 = input("Enter name of the image: ")
        img1 = "none"
        img2 = "none"

    elif(selectedAlgorithim == "noise3in3out"):
        img0 = input("Enter name of the first image: ")
        img1 = input("Enter name of the second image: ")
        img2 = input("Enter name of the third image: ")

    elif(selectedAlgorithim == "steganography3in2out"):
        img0 = input("Enter name of the first image: ")
        img1 = input("Enter name of the second image: ")
        img2 = input("Enter name of the third image: ")

    print("")

    while True:
        try:
            print("Do you want to change the brightness or contrast of the image(s)?")
            enhanceImage = input("Please enter yes or no \n")
            if((enhanceImage != "yes") and (enhanceImage != "no")):
                raise ValueError()

        except ValueError:
            print("Please enter a valid value")

            continue
        else:
            print("")
            break

    if(enhanceImage == "yes"):
        brightness = input("For brightness, enter a decimal value between 0 and 1 \n")
        contrast = input("For contrast, enter a decimal value between 0 and 1 \n")
    else:
        brightness = "1"
        contrast = "1"

    print("")

    while True:
        try:
            print("Do you want me to vectorize the results?")
            vectorize = input("Please enter yes or no \n")
            if((vectorize != "yes") and (vectorize != "no")):
                raise ValueError()

        except ValueError:
            print("Please enter a valid value")

            continue
        else:
            print("")
            break

    customFile = "none"

    if(vectorize == "yes"):
        vectorize = "true"

        while True:
            try:
                type = input("What kind of pixels do you want? Options:  rectangle, circle, triangle, custom \n")
                if((type != "rectangle") and (type != "circle") and (type != "triangle") and (type != "custom")):
                    raise ValueError()

            except ValueError:
                print("Please enter a valid value")

                continue
            else:
                print("")
                break

        if(type == "custom"):
            customFile = input("Enter name of the custom pattern image: \n")
            print("")


        while True:
            try:
                print("Do you want white pixels to be transparent?")
                transparency = input("Please enter yes or no \n")
                if((transparency != "yes") and (transparency != "no")):
                    raise ValueError()

            except ValueError:
                print("Please enter a valid value")

                continue
            else:
                print("")
                break

        while True:
            try:
                print("What pixel size do you want?")
                pixelSize = input("Please enter a number \n")
                float(pixelSize)

            except ValueError:
                print("Please enter a valid value")

                continue
            else:
                print("")
                break

        while True:
            try:
                print("What sampling frequency do you want?")
                samplingFrequency = input("Please enter a number \n")
                float(samplingFrequency)

            except ValueError:
                print("Please enter a valid value")

                continue
            else:
                print("")
                break

    else:
        vectorize = "false"
        type = "rectangle"
        transparency = "false"
        pixelSize = 1
        samplingFrequency = 1


    core = {}
    core['algorithm'] = selectedAlgorithim
    core['brightness'] = brightness
    core['contrast'] = contrast

    inputDir = "images/"
    core['img0'] = inputDir + img0
    core['img1'] = inputDir + img1
    core['img2'] = inputDir + img2

    vectorStuff = {}
    vectorStuff['vector'] = vectorize
    vectorStuff['type'] = type
    vectorStuff['customFile'] = inputDir + customFile
    vectorStuff['transparency'] = transparency
    vectorStuff['pixelSize'] = pixelSize
    vectorStuff['samplingFrequency'] = samplingFrequency

    #time to run the code
    #command = "./dist/implementation '" + str(json.dumps(core)) + "' '" + str(json.dumps(vectorStuff)) + "' "
    command = "python implementation.py '" + str(json.dumps(core)) + "' '" + str(json.dumps(vectorStuff)) + "' "
    os.system(command)


def checkLibraries():
    print("Checking libraries")
    try:
        import PIL
    except:
        install("pillow")

    try:
        import numpy
    except:
        install("numpy")

    try:
        import svgwrite
    except:
        install("svgwrite")

    try:
        import svgutils
    except:
        install("svgutils")

    install("pyinstaller")

    print("All good! \n")


def compileCode():
    print("Compiling code")
    command = 'pyinstaller implementation.py --onefile --hidden-import=svgwrite --hidden-import=numpy'
    os.system(command)
    print("Done compiling code \n")


def install(package):
    command = 'pip install ' + package
    os.system(command)

    command = 'pip3 install ' + package
    os.system(command)


if __name__ == '__main__':
    main()
