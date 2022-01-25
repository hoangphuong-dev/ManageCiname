import axios from "@/plugins/axios";

export const createMovie = async (formData = {}) => {
    return await axios.post('/movies', formData)
}

export const listMovie = async (params = {}) => {
    return await axios.get("/movies", { params });
};

export const deleteMovie = async (id) => {
    return await axios.delete("/movies/" + id);
};

export const updateMovie = async (id, formData = {}) => {
    return await axios.put("/movies/" + id + "/answer", formData);
};
