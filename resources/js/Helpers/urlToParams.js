const useUrlParam = function getUrlVars() {
    const url = window.location.href;
    var vars = {};
    url.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}


export {
    useUrlParam
}
