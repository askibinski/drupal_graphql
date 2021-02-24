import Head from 'next/head'
// Import the component from our local storybook package.
import { TextAndImage } from 'storybook-demo'
// https://www.apollographql.com/docs/react/get-started/
import { ApolloClient, InMemoryCache } from '@apollo/client';
import { gql } from '@apollo/client';

export default function Home() {

  const client = new ApolloClient({
    uri: 'http://drupal9.lndo.site/graphql',
    cache: new InMemoryCache()
  });

  client.query({
    query: gql`

    `
  })
  .then(result => console.log(result));

  // const props = {
  //   text: 'Lorem ipsum',
  //   image: {
  //     src: 'https://source.unsplash.com/random',
  //     alt: 'Random picture from unsplash',
  //     width: 600,
  //   },
  // };

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
