import axios from "@/plugins/axios";

export const createContact = async (formData = {}) => {
    return await axios.post('/contacts', formData)
}

export const listContact = async (params = {}) => {
    return await axios.get("/contacts", { params });
};

export const deleteContact = async (id) => {
    return await axios.delete("/contacts/" + id);
};

export const updateContact = async (id, formData = {}) => {
    return await axios.put("/contacts/" + id + "/answer", formData);
};
