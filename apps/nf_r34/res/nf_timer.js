var fix = 0;

function nf_timer_init(server_time) {
    var now = new Date();
    var server = new Date(server_time*1000);
    fix = now.getTime() - server.getTime();
}

function nf_timer(start) {
    now = new Date(new Date() - fix);
    var temp = new Date(start*1000);
    var diff = Math.floor((now.getTime() - temp.getTime())/1000);
    var seconds = diff%60;
    var minutes = Math.floor((diff-seconds)/60)%60;
    var hours = Math.floor((diff-seconds-minutes*60)/3600)%24;
    var days = Math.floor((diff-seconds-minutes*60-hours*3600)/(3600*24));
    if(seconds < 10) seconds = '0'+String(seconds);
    if(minutes < 10) minutes = '0'+String(minutes);
    if(hours < 10) hours = '0'+String(hours);
    var page_nf_timer = document.getElementById('nf_timer');
    page_nf_timer.innerHTML = days+'дн. '+hours+':'+minutes+':'+seconds;
}
