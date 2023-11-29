var host = import.meta.env.VITE_HOST;
import axios from 'axios';


export const cadastarUser = async (user) => {
    try {
        let res = await axios.post(host+'/users', user)
        return res
    } catch (error) {
        console.log("cadastro: "+ error);
        return error.response
    }
};