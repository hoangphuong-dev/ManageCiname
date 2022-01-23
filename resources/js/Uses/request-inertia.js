import { ElLoading } from 'element-plus';

const onError = (errors, errorValidator, $refForm, callback) => {
    for(const [key, item] of Object.entries(errors)) {
        errorValidator[key] = item;
        $refForm.validateField(key);
    }
    callable(callback, {errors});
    setTimeout(() => {
        for(const [key, item] of Object.entries(errors)) {
            errorValidator[key] = '';
        }
    }, 500)
}

const callable = (callback, arg = {}) => (callback !== null && typeof callback === 'function') && callback(arg);

var loadingService = null;
const onBefore = (callback = null) => {
    if(loadingService === null) {
        loadingService = ElLoading.service({ fullscreen: true })
    }
    callable(callback);
}

const onFinish = (callback = null) => {
    if(loadingService !== null) {
        loadingService.close();
        loadingService = null;
    }
    callable(callback);
}

export {
    onError,
    onBefore,
    onFinish
};
