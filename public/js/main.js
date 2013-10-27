function easeOutBounce(pos) {
    if ((pos) < (1/2.75)) {
        return (7.5625*pos*pos);
    } else if (pos < (2/2.75)) {
        return (7.5625*(pos-=(1.5/2.75))*pos + 0.75);
    } else if (pos < (2.5/2.75)) {
        return (7.5625*(pos-=(2.25/2.75))*pos + 0.9375);
    } else {
        return (7.5625*(pos-=(2.625/2.75))*pos + 0.984375);
    }
}

function animateScroll() {
}

(function() {
    var result = document.querySelector('.result');
    if (result) {
        var pos = 0;
        var total = result.offsetTop;

        var test = setInterval(function() {
            pos += 5;

            if (pos > total) {
                pos = total;
            }

            window.scrollTo(0, pos);

            if (pos == total) {
                clearInterval(test);
            }
        }, 1);
    }
}());