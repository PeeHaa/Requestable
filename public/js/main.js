(function() {
    var animator, total,
        result = document.querySelector('.result'),
        durationMS = 1000;

    if (result) {
        total = result.offsetTop;
        animator = new Animator(result);

        animator.registerEasingFunction("bounce", function(pos) {
            if ((pos) < (1/2.75)) {
                return (7.5625 * pos * pos);
            } else if (pos < (2 / 2.75)) {
                return (7.5625 * (pos -= (1.5 / 2.75)) * pos + 0.75);
            } else if (pos < (2.5 / 2.75)) {
                return (7.5625 * (pos -= (2.25 / 2.75)) * pos + 0.9375);
            } else {
                return (7.5625 * (pos -= (2.625 / 2.75)) * pos + 0.984375);
            }
        });

        animator.animate({
            startValue: window.scrollY,
            endValue: total,
            totalTime: durationMS,
            frameFunc: function(newValue) {
                window.scroll(window.scrollX, newValue);
            },
            easing: "bounce"
        });
    }
}());
