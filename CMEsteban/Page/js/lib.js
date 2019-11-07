function ready(fn) {
    if (document.attachEvent ? document.readyState === "complete" : document.readyState !== "loading"){
        fn();
    } else {
        document.addEventListener('DOMContentLoaded', fn);
    }
}

function forEach(array, callback) {
    return Array.prototype.filter.call(array, callback);
}

function siblings(node) {
    return forEach(node.parentNode.children, function(child) {
        return child !== node;
    });
}
