import axios from '@/plugins/axios'

export const getAllNotification = async (page = {}) => {
  return await axios.get(route('notification.getAll'), {
    params: {
      page: page
    }
  })
}

export const markRead = async (id) => {
  return await axios.get(route('notification.mark-read', id))
}


