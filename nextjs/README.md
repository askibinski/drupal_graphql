# Setup

To get this working you will need to npm link React from Storybook to the one used in Nextjs.

```
cs storybook
npm link ../nextjs/node_modules/react
```

Otherwise, the "Invalid Hook Call Warning" will appear in Nextjs.
