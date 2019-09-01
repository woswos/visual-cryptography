## tl;dr
implementation.py contains the actual code that are required to use visual cryptography functionality. It can be used as a standalone code. It was designed to work like an API and automatically. However, it is not very fun to type your data and selections in json format manually. 

So, I ended up creating interface.py as well. It does nothing but asking bunch of questions and run implementation.py based on the answers it received. Just run interface.py if you don't want to deal with json manually.

## Using implementation.py
(Optional) For compiling the executable, run: 
```
pyinstaller implementation.py --onefile --hidden-import=svgwrite
```
Here is an example usage for steganography with 3 images and getting vectorized results
```
./dist/implementation '{"algorithm": "2", "brightness":"1", "contrast":"1", "img0":"images/0.jpg", "img1":"images/1.jpg", "img2":"images/2.jpg"}' '{"vector":"true", "type":"circle", "transparent":"true", "pixelSize":"1", "samplingFrequency":"2"}'
```
Here is another example usage for steganography with one image and getting vectorized results, where each pixel is replaced with a custom shape
```
./dist/implementation '{"algorithm": "2", "brightness":"1", "contrast":"1", "img0":"images/0.jpg", "img1":"images/1.jpg", "img2":"images/2.jpg"}' '{"vector":"true", "type":"custom", "customFile":"images/leaf.svg", "transparent":"true", "pixelSize":"0.01", "samplingFrequency":"5"}'
```

## List of avaliable algorithms
noise1in2out: Input single image, get 2 meaningless noise patterns. Overlapping these two meaningless noise patterns gives the original image.

noise3in3out: Input 3 images, get 3 meaningless noise patterns. Overlapping any two meaningless noise patterns gives the one of the original image. Overlapping all of them just gives a fully black image.

steganography3in2out: Input 3 images, get first two images. Overlapping these two images gives the original image.

brightness and contrast: Using "1" doesn't make any changes on the image

Note: Given images should have the same dimensions
