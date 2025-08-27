import ReactDOM from 'react-dom/client';
import { RouterProvider, createBrowserRouter } from 'react-router-dom';
import Loading from '@General/components/Loading/Loading.tsx';

const router = createBrowserRouter([
  {
    path: '/',
    element: <div>Home Page</div>,
  },
  {
    path: '/about',
    element: <div>About Page</div>,
  },
]);

ReactDOM.createRoot(document.getElementById('root')!).render(
  <RouterProvider
    router={router}
    fallbackElement={<Loading />}
  />,
);
