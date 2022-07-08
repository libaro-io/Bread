import config from './../style_config.js'
import { ObjectByString } from './Helpers.js'

export default class Bread {
  static style (key) {
  let count = 0
    let classes = this.stripBread(key)
    while(classes.includes('@bread') && count < 10) {
      count++
      const result = classes.match(/@bread\((.*?)\)/)

      if(result.length > 0) {
        classes += this.stripBread(result[1])
        classes = classes.replace(result[0], '')
      }
    }

    return classes
  }

  static stripBread(key) {
      const regexp = /@bread\((.*?)\)/g;
      let classes = ObjectByString(config, key)

      if(!classes) {
        return key
      }

      const results = [...classes.matchAll(regexp)]

      results.forEach(result => {
        const result_stripped = result[0].replace('@bread(', '').replace(')', '')
        classes += ` ${ObjectByString(config, result_stripped)} `
        classes = classes.replace(result[0], '')
      })

      return classes
  }
}
