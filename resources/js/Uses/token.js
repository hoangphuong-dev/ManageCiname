import { useCookies } from "vue3-cookies";

const useToken = async props => {
    const api = props?.api || null;

    if(api === null) {
        return;
    }

    const { cookies } = useCookies();
    await cookies.set("token", api.token);
    await cookies.set("refresh_token", api.refresh_token);
}


export {
    useToken
}