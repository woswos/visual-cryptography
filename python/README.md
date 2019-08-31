For compiling the executable, run: 
```
pyinstaller test.py --onefile && ./dist/test noise1in2out '{"0":"test.png", "1":"test2.png"}'
```

noise1in2out: Input single image, get 2 meaningless noise patterns. Overlapping these two meaningless noise patterns gives the original image.


steganography3in2out: Input 3 images, get first two images. Overlapping these two images gives the original image.
