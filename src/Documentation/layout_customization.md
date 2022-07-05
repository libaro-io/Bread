# Customizing the layout  `version ~1.4.0`
Bread has been designed from the ground up with customization in mind.
By default, Bread will look for an optional `bread.config.js` file at the root of your project where you can define any
customizations.

Bread uses TailwindCSS classes to build its layout. You can override the styling of Bread components and colors by providing it
your own tailwind classes.

Your `bread.config.js` file will be merged with the default configuration and your customizations will be applied.

## Colors.
Override the default colors, with those of your project's style guide.

### Example
```js
module.exports = {
    colors: {
      'primary-dark': 'blue-500',
      'secondary-light': 'grey-500',
    }
}
```

### Options
- `brand`
- `primary-dark`
- `secondary-dark`
- `primary-light`
- `secondary-light`
  
### Components.
Override the default components, with those of your project's style guide.

## Example
```js
module.exports = {
  components: {
    'buttons': {
      create: 'bg-blue-500',
    },
  },
}
```

## Components.
- Buttons:
  - `create`
  - `edit`
  - `delete`
  - `cancel`
  - `save`
  - `update`
  - `reset`

- Forms:
  - `input`
  - `select`
  - `select-option`
  - `textarea`
  - `checkbox`
  - `radio`

- Tables:
  - `table`
  - `table-header`
  - `table-row`
  - `table-cell`
