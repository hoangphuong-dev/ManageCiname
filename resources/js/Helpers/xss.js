import sanitizeHtml from "sanitize-html";

export default function (xhtml) {
    return sanitizeHtml(xhtml, {
        nonTextTags: ['style', 'script', 'textarea', 'option', 'noscript', 'input'],
        allowedTags: sanitizeHtml.defaults.allowedTags.concat(['img', 'font']),
        allowedClasses: {
            '*': ['*']
        },
        allowedAttributes: {
            '*': ['title', 'style']
        }
    })
}
