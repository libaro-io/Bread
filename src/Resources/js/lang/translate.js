import { en } from './en.js'
import { nl } from './nl.js'

export default class Translate {
  static nl(key, vars = []) {
    let value = nl[key]
    if (!value) {
      return key.replaceAll('-', ' ')
    }
    vars.forEach((v, i) => {
      value = value.replace(`{${i}}`, v)
    })
    return value
  }

  static en(key, vars = []) {
    let value = en[key]
    if (!value) {
      return key.replaceAll('-', ' ')
    }
    vars.forEach((v, i) => {
      value = value.replace(`{${i}}`, v)
    })
    return value
  }

  static supportedLanguages() {
    return ['en', 'nl']
  }
}
