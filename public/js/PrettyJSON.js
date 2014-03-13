var PrettyJSON = {};

(function() {
    'use strict';

    var elementifyArray, elementifyObject, toElement;

    function addClass(el)
    {
        var i, l,
            classNames = el.className.replace(/^\s+|\s+$/g, '').split(/\s+/);

        for (i = 1, l = arguments.length; i < l; i++) {
            if (classNames.indexOf(arguments[i]) < 0) {
                classNames.push(arguments[i]);
            }
        }

        el.className = classNames.join(' ');
    }

    function removeClass(el, className)
    {
        var i, l, index,
            classNames = el.className.replace(/^\s+|\s+$/g, '').split(/\s+/);

        for (i = 1, l = arguments.length; i < l; i++) {
            index = classNames.indexOf(arguments[i]);
            if (index >= 0) {
                classNames.splice(index, 1);
            }
        }

        el.className = classNames.join(' ');
    }

    function attachBraceMatchRollover(openBrace, closeBrace)
    {
        var mouseOver = function() {
            addClass(openBrace, 'enclosure-active');
            addClass(closeBrace, 'enclosure-active');
        },
        mouseOut = function() {
            removeClass(openBrace, 'enclosure-active');
            removeClass(closeBrace, 'enclosure-active');
        };

        openBrace.addEventListener('mouseover', mouseOver);
        openBrace.addEventListener('mouseout', mouseOut);
        closeBrace.addEventListener('mouseover', mouseOver);
        closeBrace.addEventListener('mouseout', mouseOut);
    }

    function getPadding(count)
    {
        var i, result = '';

        for (i = 0; i < count; i++) {
            result += ' ';
        }

        return result;
    }

    function extractLinks(str)
    {
        var match, anchor, parts = [], p = 0,
            urlExpr = /\bhttps?:\/\/[^\/]+\/\S*/g;

        while (match = urlExpr.exec(str)) {
            if (p < match.index) {
                parts.push(document.createTextNode(str.slice(p, match.index)));
            }
            p = match.index + match[0].length;

            anchor = document.createElement('a');
            anchor.href = match[0];
            anchor.target = '_blank';
            anchor.appendChild(document.createTextNode(JSON.stringify(match[0]).slice(1, -1)));
            parts.push(anchor);
        }

        if (parts.length) {
            if (p < str.length - 1) {
                parts.push(document.createTextNode(str.slice(p)));
            }

            return parts;
        }
    }

    elementifyArray = function(arr, indent)
    {
        var i, l, container, member, wrapper;

        container = document.createElement('div');
        container.className = 'object-body';

        for (i = 0, l = arr.length; i < l; i++) {
            member = document.createElement('div');
            member.className = 'object-member';
            member.appendChild(document.createTextNode(getPadding(indent)));

            toElement(arr[i], member, indent);

            wrapper = document.createElement('span');
            wrapper.className = 'object-delimiter json-grammar';
            wrapper.appendChild(document.createTextNode(','));
            member.appendChild(wrapper);

            container.appendChild(member);
        }

        if (container.lastChild) {
            container.lastChild.removeChild(container.lastChild.lastChild);
        }

        return container;
    };

    elementifyObject = function(obj, indent)
    {
        var key, container, member, wrapper;

        container = document.createElement('div');
        container.className = 'object-body';

        for (key in obj) {
            if (obj.hasOwnProperty(key) && typeof obj[key] !== 'function') {
                member = document.createElement('div');
                member.className = 'object-member';
                member.appendChild(document.createTextNode(getPadding(indent)));

                wrapper = document.createElement('span');
                wrapper.className = 'object-member-key';
                toElement(String(key), wrapper, indent);
                member.appendChild(wrapper);

                wrapper = document.createElement('span');
                wrapper.className = 'object-delimiter json-grammar';
                wrapper.appendChild(document.createTextNode(' : '));
                member.appendChild(wrapper);

                wrapper = document.createElement('span');
                wrapper.className = 'object-member-value';
                toElement(obj[key], wrapper, indent);
                member.appendChild(wrapper);

                wrapper = document.createElement('span');
                wrapper.className = 'object-delimiter json-grammar';
                wrapper.appendChild(document.createTextNode(','));
                member.appendChild(wrapper);

                container.appendChild(member);
            }
        }

        if (container.lastChild) {
            container.lastChild.removeChild(container.lastChild.lastChild);
        }

        return container;
    };

    toElement = function(obj, container, indent)
    {
        var wrapper, anchor, openBrace, closeBrace, parts, i, l;

        if (!container) {
            container = document.createElement('div');
            container.className = 'pretty-json-container';
        }
        indent = indent || 0;

        switch (typeof obj) {
            case 'string':
                if (parts = extractLinks(obj)) {
                    wrapper = document.createElement('span');
                    wrapper.className = 'value-string';
                    wrapper.title = 'String';

                    wrapper.appendChild(document.createTextNode('"'));
                    for (i = 0, l = parts.length; i < l; i++) {
                        wrapper.appendChild(parts[i]);
                    }
                    wrapper.appendChild(document.createTextNode('"'));

                    container.appendChild(wrapper);
                    break;
                }

            case 'number': case 'boolean':
                wrapper = document.createElement('span');
                wrapper.className = 'value-' + (typeof obj);
                wrapper.title = (typeof obj).slice(0, 1).toUpperCase() + (typeof obj).slice(1);
                wrapper.appendChild(document.createTextNode(JSON.stringify(obj)));

                container.appendChild(wrapper);
                break;

            case 'object':
                if (obj === null) {
                    wrapper = document.createElement('span');
                    wrapper.className = 'value-null';
                    wrapper.title = 'Null';
                    wrapper.appendChild(document.createTextNode(JSON.stringify(obj)));

                    container.appendChild(wrapper);
                } else if (obj instanceof Array) {
                    openBrace = document.createElement('span');
                    openBrace.className = 'array-enclosure json-grammar';
                    openBrace.appendChild(document.createTextNode('['));
                    closeBrace = document.createElement('span');
                    closeBrace.className = 'array-enclosure json-grammar';
                    openBrace.title = closeBrace.title = 'Array (' + obj.length + ' element' + (obj.length === 1 ? '' : 's') + ')';
                    attachBraceMatchRollover(openBrace, closeBrace);

                    container.appendChild(openBrace);

                    if (obj.length) {
                        container.appendChild(elementifyArray(obj, indent + 4));
                        closeBrace.appendChild(document.createTextNode(getPadding(indent) + ']'));
                    } else {
                        closeBrace.appendChild(document.createTextNode(']'));
                    }

                    container.appendChild(closeBrace);
                } else {
                    openBrace = document.createElement('span');
                    openBrace.className = 'object-enclosure';
                    openBrace.appendChild(document.createTextNode('{'));
                    closeBrace = document.createElement('span');
                    closeBrace.className = 'object-enclosure';

                    wrapper = elementifyObject(obj, indent + 4);

                    openBrace.title = closeBrace.title = 'Object (' + wrapper.childNodes.length + ' member' + (wrapper.childNodes.length === 1 ? '' : 's') + ')';
                    attachBraceMatchRollover(openBrace, closeBrace);

                    container.appendChild(openBrace);

                    if (wrapper.childNodes.length) {
                        container.appendChild(wrapper);
                        closeBrace.appendChild(document.createTextNode(getPadding(indent) + '}'));
                    } else {
                        closeBrace.appendChild(document.createTextNode('}'));
                    }

                    container.appendChild(closeBrace);
                }
                break;
        }

        return container;
    };

    PrettyJSON.elementify = function(obj)
    {
        return toElement(obj);
    };

    PrettyJSON.stringify = function(obj)
    {
        return toElement(obj).outerHTML;
    };

    JSON.prettify = PrettyJSON.elementify;
}());
