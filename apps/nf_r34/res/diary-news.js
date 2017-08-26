function diary_news_change() {
    var obj = document.getElementById('diary-news__body');
    var text = document.getElementById('diary-news__link');
    if(obj.style.display != 'none') {
        obj.style.display = 'none';
        text.innerText = '[Показать]';
    } else{
        obj.style.display = 'block';
        text.innerText = '[Скрыть]';
    }
}

var w = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
if(w < 720) {
    var obj = document.getElementById('diary-news__body');
    var text = document.getElementById('diary-news__link');
    obj.style.display = 'none';
    text.innerText = '[Показать]';
}
