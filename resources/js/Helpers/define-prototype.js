String.prototype.toInt = function () {
    return Number.parseInt(this) || 0;
};

Object.defineProperty(Array.prototype, "last", {
    value: function() {
        if (this.length == 0) {
            return null;
        }
        return this[this.length - 1];
    }
});

Object.defineProperty(Array.prototype, "first", {
    value: function() {
        if (this.length == 0) {
            return null;
        }
        return this[0];
    }
});