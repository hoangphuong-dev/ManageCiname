export default {
    methods: {
        async $shortConfirm(
            msg,
            options = {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning',
            }
        ) {
            return new Promise((resolve) => {
                this.$confirm(msg, 'Warning', options)
                    .then((_) => {
                        resolve(true)
                    })
                    .catch((_) => {
                        resolve(false)
                    })
            })
        },
    },
}
