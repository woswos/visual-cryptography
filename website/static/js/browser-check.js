var ua = navigator.userAgent.toLowerCase();
  if (ua.indexOf('safari') != -1) {
    if (ua.indexOf('chrome') > -1) {
      //alert("1") // Chrome
    } else {
      alert("This page is not optimized for safari browser, please use chrome browser") // Safari
    }
  }
