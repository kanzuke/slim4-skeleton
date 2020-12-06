function getRandomColor() {
    var letters = '789ABCD'.split('');
    var color = '#';
    for (var i = 0; i < 6; i++ ) {
        color += letters[Math.round(Math.random() * 6)];
    }
    return color;
}
