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

export const createAdmin = async (formData = {}) => {
    return await axios.post('/admins', formData)
};

export const listAdmin = async (params = {}) => {
    return await axios.get("/admins", { params });
};

export const createMovieGenre = async (formData = {}) => {
    return await axios.post('/moviegenres', formData);
}

export const listMovieGenre = async (params = {}) => {
    return await axios.get("/moviegenres", { params });
};

export const createCast = async (formData = {}) => {
    return await axios.post('/casts', formData);
}

export const listCast = async (params = {}) => {
    return await axios.get("/casts", { params });
};
