import axios from '@/plugins/axios'

export const listUser = async (params = {}) => {
  return await axios.get('/users', { params })
}

export const updateStatus = async (id, status) => {
  return await axios.put('/users/' + id + '/update-status', { status })
}

export const updateProfile = async (formData = {}) => {
  return await axios.post('/user/update-profile', formData)
}

export const commentJob = async (id, formData = {}) => {
  return await axios.post('/caretaker/jobs/comment/' + id, formData)
}
