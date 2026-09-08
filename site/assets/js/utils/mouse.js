// Track mouse position

// get the mouse position
const getMousePos = (ev) => {
   let posx = 0;
   let posy = 0;
   if (!ev) ev = window.event;
   if (ev.pageX || ev.pageY) {
       posx = ev.pageX;
       posy = ev.pageY;
   }
   else if (ev.clientX || ev.clientY)  {
       posx = ev.clientX/* + body.scrollLeft + docEl.scrollLeft*/;
       posy = ev.clientY/* + body.scrollTop + docEl.scrollTop*/;
   }
   return {x: posx, y: posy};
}

// mousePos: current mouse position
// cacheMousePos: previous mouse position
// lastMousePos: last last recorded mouse position (at the time the last image was shown)
let mousePos = lastMousePos = cacheMousePos = {x: 0, y: 0};

// update the mouse position
window.addEventListener('mousemove', ev => mousePos = getMousePos(ev));