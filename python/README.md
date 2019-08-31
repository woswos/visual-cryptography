For compiling the executable, run: 
```
pyinstaller test.py --onefile --hidden-import=svgwrite
./dist/test '{"algorithm": "2", "brightness":"1", "contrast":"1", "img0":"images/0.jpg", "img1":"images/1.jpg", "img2":"images/2.jpg"}' '{"vector":"true", "type":"circle", "transparent":"true", "pixelSize":"1", "samplingFrequency":"2"}'
```
```
pyinstaller test.py --onefile --hidden-import=svgwrite
./dist/test '{"algorithm": "2", "brightness":"1", "contrast":"1", "img0":"images/0.jpg", "img1":"images/1.jpg", "img2":"images/2.jpg"}' '{"vector":"true", "type":"custom", "customFile":"images/leaf.svg", "transparent":"true", "pixelSize":"0.01", "samplingFrequency":"5"}'
```

noise1in2out: Input single image, get 2 meaningless noise patterns. Overlapping these two meaningless noise patterns gives the original image.

noise3in3out: Input 3 images, get 3 meaningless noise patterns. Overlapping any two meaningless noise patterns gives the one of the original image. Overlapping all of them just gives a fully black image.

steganography3in2out: Input 3 images, get first two images. Overlapping these two images gives the original image.

brightness and contrast: Using "1" doesn't make any changes on the image

Note: Given images should have the same dimensions


