import Head from 'next/head'
// Import the component from our local storybook package.
import { TextAndImage } from 'storybook-demo'
// https://www.apollographql.com/docs/react/get-started/
import {ApolloClient, useQuery, InMemoryCache, gql} from '@apollo/client';

const client = new ApolloClient({
  uri: 'http://drupal9.lndo.site/graphql',
  cache: new InMemoryCache()
});

const MY_QUERY = gql`
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
                src
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

export default function Home() {

  // The recommended way is to pass the client via context, but to keep our demo simple we pass it in useQuery.
  const { loading, error, data } = useQuery(MY_QUERY, { client: client });

  if (loading) return <p>Loading...</p>;

  if (error) {
    console.log(error);
    return <p>Error :( (see console)</p>;
  }

  // Of course this code will fail when something else than the expected TextAndImage paragraph is returned. But
  // it is only for demo purposes.
  const props = {
    text: data.nodeByID.content[0].text,
    image: data.nodeByID.content[0].image[0]
  };

  console.log(props);

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
