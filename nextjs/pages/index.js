import Head from 'next/head'
import { TextAndImage } from 'storybook-demo'

export default function Home() {

  // @todo get this from graphql.
  const props = {
    text: 'Lorem ipsum',
    image: {
      src: 'https://source.unsplash.com/random',
      alt: 'Random picture from unsplash',
      width: 600,
    },
  };

  return (
    <div className="container">
      <Head>
        <title>Demo component from Storybook</title>
        <link rel="icon" href="/favicon.ico" />
      </Head>

      <TextAndImage {...props} />

    </div>
  )
}
