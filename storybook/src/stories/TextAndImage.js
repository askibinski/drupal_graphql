import { Box, Grid } from '@material-ui/core'
import React from 'react';
import './text-and-image.css';

/**
 * Text and Image component.
 */
export const TextAndImage = ({ text, image }) => {

  const RichTextItem = (
    <Grid item>
      <div dangerouslySetInnerHTML={{ __html: text }}></div>
    </Grid>
  )

  const ImageItem =
    image && image.src ? (
      <Grid item>
        <Box width="100%">
          <img {...image} />
        </Box>
      </Grid>
    ) : (
      ''
    )

  return (
    <Grid container spacing={3}>
      {ImageItem}
      {RichTextItem}
    </Grid>
  );
};
