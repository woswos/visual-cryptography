#!/usr/bin/python3

import svgwrite
from matplotlib.image import imread
import numpy as np
import sys

image = imread(str(sys.argv[1]))
dwg = svgwrite.Drawing(str(sys.argv[2]))

transparency = sys.argv[3]

pixelSize = 1
x = 0
y = 0

for yPixel in range(image.shape[0]):
    for xPixel in range(image.shape[1]):
        pixelColor = image[yPixel][xPixel]
        #print(pixelColor)
        if(pixelColor < 0.5):
            dwg.add(dwg.rect((xPixel, yPixel), (pixelSize, pixelSize), fill='black'))
        else:
            if(transparency == "transparency=false"):
                dwg.add(dwg.rect((xPixel, yPixel), (pixelSize, pixelSize), fill='white'))

dwg.save()
