For compiling the executable, run: 
```
pyinstaller test.py --onefile --hidden-import=Module && ./dist/test noise1in2out '{"0":"test.png", "1":"test2.png"}'
```

noise1in2out: Input single image, get 2 meaningless noise patterns. Overlapping these two meaningless noise patterns gives the original image.

noise3in3out: Input 3 images, get 3 meaningless noise patterns. Overlapping any two meaningless noise patterns gives the one of the original image. Overlapping all of them just gives a fully black image.

steganography3in2out: Input 3 images, get first two images. Overlapping these two images gives the original image.

Note: Given images should have the same dimensions
