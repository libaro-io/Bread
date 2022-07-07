# Customizing the layout  `version ~1.4.0`

Bread has been designed from the ground up with customization in mind. You can change the styling of certain elements by
changing them in `Bread/Resources/js/style_config.js`.

Bread uses TailwindCSS classes to build its layout. You can override the styling of Bread components and colors by
providing it your own tailwind classes.

### style_config.js

```js
export default {
    colors: {
        success: 'bg-green-600 hover:bg-red-700',
        danger: 'bg-red-600 hover:bg-red-700',
        info: 'bg-blue-600 hover:bg-blue-700',
    },
    rings: {
        danger: '@bread(colors.danger) focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2'
    },
    buttons: {
        danger: ' @bread(rings.danger) inline-flex w-full justify-center rounded-md border border-transparent px-4 py-2 text-base font-medium text-white shadow-sm sm:col-start-2 sm:text-sm'
    },
}
```
