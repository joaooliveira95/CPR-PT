function setIntervalLimited(callback, interval, x) {
    flag = 0;
    for (var i = 0; i < x; i++) {
        setTimeout(callback, i * interval);
    }
}
