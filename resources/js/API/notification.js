import axios from '@/plugins/axios'

export const listReceiver = async (params = {}) => {
  return await axios.get('/admin/notification/list-receiver', { params })
}
