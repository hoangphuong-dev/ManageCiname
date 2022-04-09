import axios from '@/plugins/axios'

export const listJob = async (params = {}) => {
  return await axios.get('/hospital/jobs/get-list-job', { params })
}

export const detailJob = async (id) => {
  return await axios.get('/jobs/' + id)
}

export const createJob = async (formData = {}) => {
  return await axios.post('/jobs', formData)
}

export const updateJob = async (id, formData = {}) => {
  return await axios.post('/jobs/' + id, formData)
}

export const getListCaretakerApplyJob = async (job_id) => {
  return await axios.post('/hospital/jobs/get-caretaker-apply-job', {
    job_id,
  })
}

export const checkDeleteProcess = async (job_id, job_process_id) => {
  return await axios.get('hospital/jobs/check-detele-process/' + job_id + '/' + job_process_id)
}
