const useScript = (src) => {
    var head = document.getElementsByTagName("head")[0];
    var script = document.createElement("script");
    script.type = "text/javascript";
    script.src = src;
    script.async = true;
    head.appendChild(script);

    return script;
};

export { useScript };
