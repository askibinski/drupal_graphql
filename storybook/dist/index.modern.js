import { Grid, Box } from '@material-ui/core';
import React from 'react';

const TextAndImage = ({
  text,
  image
}) => {
  const RichTextItem = /*#__PURE__*/React.createElement(Grid, {
    item: true
  }, /*#__PURE__*/React.createElement("div", {
    dangerouslySetInnerHTML: {
      __html: text
    }
  }));
  const ImageItem = image && image.src ? /*#__PURE__*/React.createElement(Grid, {
    item: true
  }, /*#__PURE__*/React.createElement(Box, {
    width: "100%"
  }, /*#__PURE__*/React.createElement("img", image))) : '';
  return /*#__PURE__*/React.createElement(Grid, {
    container: true,
    spacing: 3
  }, ImageItem, RichTextItem);
};

export { TextAndImage };
//# sourceMappingURL=index.modern.js.map
