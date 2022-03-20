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

export const updateStatusMovie = async (id, status) => {
    return await axios.put('/movies/' + id + '/update-status', { status })
}

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

export const listFormat = async (params = {}) => {
    return await axios.get("/formats", { params });
};

export const createFormat = async (formData = {}) => {
    return await axios.post('/formats', formData);
}

export const createSeatType = async (formData = {}) => {
    return await axios.post('/seat_types', formData);
}

export const listSeatType = async (params = {}) => {
    return await axios.get("/seat_types", { params });
};

export const listRoom = async (params = {}) => {
    return await axios.get("/rooms", { params });
};

export const updateStatusRoom = async (id, status) => {
    return await axios.put('/rooms/' + id + '/update-status', { status })
}

export const listShowTimeByRoom = async (id) => {
    return await axios.get("/showtimes/room/" + id);
};

export const listScheduleByDay = async (params = {}) => {
    return await axios.get("/showtimes", { params });
};

