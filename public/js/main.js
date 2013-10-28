(function() {
    function scrollTheThing(result) {
        var total    = result.offsetTop,
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
            totalTime: 1000,
            frameFunc: function(newValue) {
                window.scroll(window.scrollX, newValue);
            },
            easing: "bounce"
        });
    }

    // this will make @daverandom (and every other sane person) cry
    function stringToHtml(string) {
        var container = document.createElement('div');
        container.innerHTML = string;

        return container.childNodes;
    }

    var result = document.querySelector('.result');

    if (result) {
        scrollTheThing(result);
    }

    var form = document.querySelector('form');
    $(form).on('submit', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState < 4 || xhr.status !== 200) {
                return;
            }

            if (xhr.readyState === 4) {
                var data = JSON.parse(xhr.responseText);

                var results = document.querySelectorAll('.result');
                for (var i =0, l = results.length; i < l; i++) {
                    results[i].parentNode.removeChild(results[i]);
                }

                var content = document.querySelector('#body .content');
                var newResults = stringToHtml(data.result);
                for (var i = 0, l = newResults.length; i < l; i++) {
                    if (typeof newResults[i] === 'undefined' || newResults[i].nodeType === 3) {
                        continue;
                    }

                    content.appendChild(newResults[i]);
                }

                scrollTheThing(document.querySelector('.result'));
            }
        }
        xhr.open(form.getAttribute('method'), '/', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.send($(form).serialize());
    });
}());
