import Head from 'next/head'
// Import the component from our local storybook package.
import { TextAndImage } from 'storybook-demo'
// https://www.apollographql.com/docs/react/get-started/
import {ApolloClient, InMemoryCache, useQuery} from '@apollo/client';
import { gql } from '@apollo/client';

export default function Home() {

  const client = new ApolloClient({
    uri: 'http://drupal9.lndo.site/graphql',
    cache: new InMemoryCache()
  });

  const QUERY = gql`
    query {
      nodeByID(id: 1) {
        ... on Page {
          id
          content {
            ... on ParagraphTextAndImage {
              image {
                ... on Image {
                  id
                  height
                  alt
                  url
                  width
                }
              }
              text
            }
          }
          title
        }
      }
    }
  `;


  const { loading, error, data } = useQuery(QUERY, { client: client, fetchPolicy: "no-cache" });

  if (loading) {
    console.log(loading);
  }
  if (error) {
    console.log(error);
  }

  // Fuck why is loading stuck on true?
  console.log(data);

  const props2 = {
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

      <TextAndImage {...props2} />

    </div>
  )
}
