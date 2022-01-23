export default {
    methods: {
        isValidHttpUrl(string) {
            let url;

            try {
                url = new URL(string);
            } catch (_) {
                return false;
            }

            return url.protocol === "http:" || url.protocol === "https:";
        },
        getImage(file) {
            if (!file) return;

            if (this.isValidHttpUrl(file)) return file;
            
            return `/storage/${file}`;
        },
    },
};
