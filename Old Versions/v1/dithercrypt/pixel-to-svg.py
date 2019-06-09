#!/usr/bin/python3

import svgwrite
from matplotlib.image import imread
import numpy as np
import sys

image = imread(str(sys.argv[1]))
dwg = svgwrite.Drawing(filename = str(sys.argv[2]), profile='tiny')


pixelSize = int(sys.argv[5])
pixelSamplingFreq = int(sys.argv[6])

x = 0
y = 0

if(sys.argv[4] == "shape=rectangle"):
    for yPixel in range(image.shape[0], pixelSamplingFreq):
        for xPixel in range(image.shape[1], pixelSamplingFreq):
            pixelColor = image[yPixel][xPixel]
            if(str(sys.argv[3]) == "transparency=false"):
                if(pixelColor < 0.5):
                    dwg.add(dwg.rect((xPixel, yPixel), (pixelSize, pixelSize), fill='black'))
                else:
                    dwg.add(dwg.rect((xPixel, yPixel), (pixelSize, pixelSize), fill='white'))
            else:
                if(pixelColor[0] < 0.5):
                    dwg.add(dwg.rect((xPixel, yPixel), (pixelSize, pixelSize), fill='black'))


if(sys.argv[4] == "shape=circle"):
    for yPixel in range(0, image.shape[0], pixelSamplingFreq):
        for xPixel in range(0, image.shape[1], pixelSamplingFreq):
            pixelColor = image[yPixel][xPixel]
            if(str(sys.argv[3]) == "transparency=false"):
                if(pixelColor < 0.5):
                    dwg.add(dwg.circle((xPixel, yPixel), pixelSize, fill='black'))
                else:
                    dwg.add(dwg.circle((xPixel, yPixel), pixelSize, fill='white'))
            else:
                if(pixelColor[0] < 0.5):
                    dwg.add(dwg.circle((xPixel, yPixel), pixelSize, fill='black'))


if(sys.argv[4] == "shape=triangle"):
    flip = False
    for yPixel in range(0, image.shape[0], pixelSamplingFreq):
        for xPixel in range(0, image.shape[1], pixelSamplingFreq):
            pixelColor = image[yPixel][xPixel]
            print(pixelColor)
            if(str(sys.argv[3]) == "transparency=false"):
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
                    if(pixelColor[0] < 0.5):
                        dwg.add(dwg.polygon([(xPixel,yPixel), ((xPixel+pixelSize), (yPixel+pixelSize)), ((xPixel+(pixelSize*2)),yPixel)]))
                        flip = False
                else:
                    if(pixelColor[0] < 0.5):
                        dwg.add(dwg.polygon([(xPixel,yPixel+pixelSize), (xPixel+pixelSize,yPixel), ((xPixel+(pixelSize*2)),(yPixel+pixelSize))]))
                        flip = True

#dwg.add(dwg.polygon([(0,0), (100,100), (200,0)]))
#dwg.add(dwg.polygon([(0,100), (100,0), (200,100)]))

dwg.save()
