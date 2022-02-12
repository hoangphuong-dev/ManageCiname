import axios from "@/plugins/axios";



export const listMovieGenre = async (params = {}) => {
    return await axios.get("/moviegenres", { params });
};

export const deleteMovieGenre = async (id) => {
    return await axios.delete("/moviegenres/" + id);
};

export const updateMovieGenre = async (id, formData = {}) => {
    return await axios.put("/moviegenres/" + id + "/answer", formData);
};
