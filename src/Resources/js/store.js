import { defineStore } from 'pinia'
import { v4 as uuidv4 } from 'uuid'
import Translate from './lang/translate'

export const useBreadStore = defineStore('bread', {
  state: () => {
    return {
      key: 0,
      lang: 'en',
      resource: null,
      notifications: [],
      user: null,
      categories: [],
      selected_category: null,
      filters: {},
      show_filters: false,
    }
  },
  getters: {
    isCurrent: (state) => {
      return (resource) => resource === state.resource
    },
    getNotifications: (state) => {
      return state.notifications
    },
    numberOfUnreadNotifications: (state) => {
      return state.notifications.filter((notification) => !notification.read)
        .length
    },
    showFilters: (state) => {
      return state.show_filters
    },
    getKey: (state) => {
      return state.key
    },
  },
  actions: {
    translate(key, { replace = [], ucfirst = false } = {}) {
      let result = Translate[this.lang](key, replace)
      if (ucfirst) {
        result = result.charAt(0).toUpperCase() + result.slice(1)
      }

      return result
    },
    setResource(resource) {
      this.resource = resource
    },
    setUser(user) {
      this.user = user
    },
    setNotifications(notifications) {
      const _notifications = Object.values(notifications)
      this.notifications = _notifications.map((notification) => {
        return {
          ...notification,
          read: false,
        }
      })
    },
    markNotificationAsRead(notification) {
      this.notifications = this.notifications.map((n) => {
        if (n.type === notification.type) {
          return {
            ...n,
            read: true,
          }
        }
        return n
      })
    },
    markNotificationAsUnread(notification) {
      this.notifications = this.notifications.map((n) => {
        if (n.id === notification.id) {
          return {
            ...n,
            read: false,
          }
        }
        return n
      })
    },
    setCategories(categories) {
      this.categories = categories
    },
    setSelectedCategory(category) {
      this.selected_category = category
    },
    setFilters(resource, filters) {
      if (!filters.hasOwnProperty('data')) {
        return
      }
      if (this.filters.hasOwnProperty(this.resource)) {
        return
      }

      this.filters[resource] = {
        data: filters.data.map((filter) => {
          return {
            ...filter,
            uuid: uuidv4(),
          }
        }),
        options: filters.options,
      }
    },
    setFilterValue(uuid, newValue) {
      if (!this.resourceHasFilters()) {
        return
      }
      this.filters[this.resource].data = this.filters[this.resource].data.map(
        (filter) => {
          if (filter.uuid === uuid) {
            return {
              ...filter,
              value: newValue,
            }
          }
          return filter
        }
      )
    },
    toggleShowFilters(show) {
      this.show_filters = !this.show_filters
    },
    getFilters() {
      return this.filters[this.resource]?.data
    },
    getFilterOptions() {
      return this.filters[this.resource]?.options
    },
    resourceHasFilters() {
      return !!this.filters[this.resource]
    },
    showFiltersInline() {
      return (
        this.filters[this.resource].data.length <
        this.filters[this.resource].options.sidebar_starts_at
      )
    },
    unsetFilters() {
      delete this.filters[this.resource]
    },
    setLang(lang) {
      if (Translate.supportedLanguages().includes(lang)) {
        this.lang = lang
      } else {
        console.error(
          `%cBread >> %c'${lang}' is not a supported language.`,
          'color: blue',
          'color: red'
        )
        console.error(
          `%cBread >> %cdefault language '${this.lang}' used instead.`,
          'color: blue',
          'color: red'
        )
      }
    },
  },
})
