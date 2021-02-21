import React from 'react';

import { TextAndImage } from './TextAndImage';

export default {
  title: 'Example/TextAndImage',
  component: TextAndImage,
};

const Template = (args) => <TextAndImage {...args} />;

export const ImageLeft = Template.bind({});
ImageLeft.args = {
  text: 'Lorem ipsum',
  image: {
    src: 'https://source.unsplash.com/random',
    alt: 'Random picture from unsplash',
    width: 600,
  },
};
