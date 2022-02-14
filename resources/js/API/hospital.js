import axios from '@/plugins/axios'

export const updateProfile = async (formData = {}) => {
  return await axios.post('/hospital/update-profile', formData)
}

export const listCommentJob = async (id, params = {}) => {
  return await axios.get('hospital/jobs/get-list-comment/' + id, { params })
}

export const updateStatusComment = async (commentId, status = {}) => {
  return await axios.put('hospital/jobs/update-status-comment/' + commentId, { status })
}
