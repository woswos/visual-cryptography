/** Taken from https://jsfiddle.net/remarkablemark/93gfvjmw/ **/

'use strict';

/**
 * Makes an element draggable.
 *
 * @param {HTMLElement} element - The element.
 */
function draggable(element) {
  var isMouseDown = false;

  // initial mouse X and Y for `mousedown`
  var mouseX;
  var mouseY;

  // element X and Y before and after move
  var elementX = 0;
  var elementY = 0;

  // mouse button down over the element
  element.addEventListener('mousedown', onMouseDown);

  /**
   * Listens to `mousedown` event.
   *
   * @param {Object} event - The event.
   */
  function onMouseDown(event) {
    mouseX = event.clientX;
    mouseY = event.clientY;
    isMouseDown = true;
  }

  // mouse button released
  element.addEventListener('mouseup', onMouseUp);

  /**
   * Listens to `mouseup` event.
   *
   * @param {Object} event - The event.
   */
  function onMouseUp(event) {
    isMouseDown = false;
    elementX = parseInt(element.style.left) || 0;
    elementY = parseInt(element.style.top) || 0;
    isMouseDown = false;
  }

  // need to attach to the entire document
  // in order to take full width and height
  // this ensures the element keeps up with the mouse
  document.addEventListener('mousemove', onMouseMove);

  /**
   * Listens to `mousemove` event.
   *
   * @param {Object} event - The event.
   */
  function onMouseMove(event) {

    if (isMouseDown) {
      isMouseDown = false;
      var deltaX = event.clientX - mouseX;
      isMouseDown = false;
      var deltaY = event.clientY - mouseY;
      isMouseDown = false;
      element.style.left = elementX + deltaX + 'px';
      isMouseDown = false;
      element.style.top = elementY + deltaY + 'px';
      isMouseDown = false;
    } else {
      isMouseDown = false;
    }

  }
}

document.onkeyup = function(e) {
  if (e.which == 65) {
    document.getElementById("output1").style.top = "0px";
    document.getElementById("output1").style.left = "0px";
    document.getElementById("output2").style.top = "0px";
    document.getElementById("output2").style.left = "0px";
    draggable.isMouseDown = false;
  }
};

draggable(document.getElementById('output1'));
draggable(document.getElementById('output2'));
