const useValidator = (callback, validatorError, field) => {
    if (validatorError[field].trim() !== '') {
        return callback(validatorError[field])
    }
    callback();
}


export {
    useValidator
}
