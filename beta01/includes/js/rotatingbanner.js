/*
	Image Cross Fade Redux	Version 1.0	Last revision: 02.15.2006	steve@slayeroffice.com
	Rewrite of old code found here: http://slayeroffice.com/code/imageCrossFade/index.html	
  css = d.createElement('link');	css.setAttribute('href','/css/js_css/rotator.css');	
  css.setAttribute('rel','stylesheet');  css.setAttribute('type','text/css');
  d.getElementsByTagName('head')[0].appendChild(css);	
*/

window.addEventListener?window.addEventListener('load',so_init,false):window.attachEvent('onload',so_init);

var d=document, imgs = new Array(), zInterval = null, current=0, pause=false;

function so_init()
{
	if(!d.getElementById || !d.createElement)return;

	imgs = d.getElementById('rotator').getElementsByTagName('div');
	for(i=1;i<imgs.length;i++) imgs[i].xOpacity = 0;
	imgs[0].style.display = 'block';
	imgs[0].xOpacity = .99;

	setTimeout(so_xfade,500);
}

function so_xfade()
{
  if(pause)return;  

	cOpacity = imgs[current].xOpacity;
	nIndex = imgs[current+1]?current+1:0;
	nOpacity = imgs[nIndex].xOpacity;

	cOpacity-=.05;
	nOpacity+=.05;

	imgs[nIndex].style.display = 'block';
	imgs[current].xOpacity = cOpacity;
	imgs[nIndex].xOpacity = nOpacity;

	setOpacity(imgs[current]);
	setOpacity(imgs[nIndex]);

	if(cOpacity<=0)
	{
		imgs[current].style.display = 'none';
		current = nIndex;
		setTimeout(so_xfade,8000);
	}
	else
	{
		setTimeout(so_xfade,50);
	}

	function setOpacity(obj)
	{
		if(obj.xOpacity>.99)
		{
			obj.xOpacity = .99;
			return;
		}

		obj.style.opacity = obj.xOpacity;
		obj.style.MozOpacity = obj.xOpacity;
		obj.style.filter = 'alpha(opacity=' + (obj.xOpacity*100) + ')';
	}
}

function stoponthis(v)
{
  for(i=0;i<imgs.length;i++) 
  imgs[i].style.display = 'none';
  imgs[v].style.display = 'block';
  imgs[v].style.opacity = .99
  imgs[v].style.MozOpacity = .99
  imgs[v].style.filter = 'alpha(opacity=' + 100 + ')';
  pause=true;
}

function pause_rotator()
{
pause = true;
}

function play_rotator()
{
if(pause){
pause=true;
}else {
pause=false;return;
}
}

function doPause()  {
	if(pause) {
		pause = false;
	} else {
		pause = true;return;
	}
}
