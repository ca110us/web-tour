var displayedImage = document.querySelector('.displayed-img');
var thumbBar = document.querySelector('.thumb-bar');

btn = document.querySelector('button');
var overlay = document.querySelector('.overlay');

/* Looping through images */

for (let index = 1; index <= 5; index++) {
  var newImage = document.createElement('img');
  newImage.setAttribute('src', 'images/pic' + index +'.jpg');
  newImage.addEventListener('click', changeImg);
  thumbBar.appendChild(newImage);
}

function changeImg(e) {
  // newSrc = e.target.currentSrc;
  /* 刚开始不知道src是target里哪个属性 就console.log(e) 找了一下*/
  // displayedImage.setAttribute('src',newSrc);
  // 后来发现上面的方法获取的是服务器绝对路径 暴露出来不太好
  // 也可以使用 getAttribute 获取src属性值 不过我认为这样更简单
  newSrc = e.target.attributes.src.nodeValue;
  displayedImage.setAttribute('src',newSrc);
}

/* Wiring up the Darken/Lighten button */

btn.addEventListener('click',changeDarkenOrLighten)

function changeDarkenOrLighten() {
  if (btn.getAttribute('class')=='dark') {
    btn.setAttribute('class', 'light');
    btn.textContent = 'Lighten';
    overlay.style.backgroundColor = 'rgba(0,0,0,0.5)';
  }else{
    btn.setAttribute('class', 'dark');
    btn.textContent = 'Darken';
    overlay.style.backgroundColor = 'rgba(0,0,0,0)';
  }
}
