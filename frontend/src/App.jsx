import { Route, Routes } from 'react-router-dom'
import AppLayout from './layouts/AppLayout'
import NotFoundPage from './pages/NotFoundPage'
import { APP_ROUTES, HomeRedirect, RequireRole } from './routes'
import { navByKey } from './config/navigation'

export default function App() {
  return (
    <Routes>
      <Route element={<AppLayout />}>
        <Route index element={<HomeRedirect />} />

        {APP_ROUTES.map(({ key, element }) => {
          const nav = navByKey[key]
          return (
            <Route
              key={key}
              path={nav.path}
              element={<RequireRole roles={nav.roles}>{element}</RequireRole>}
            />
          )
        })}

        <Route path="*" element={<NotFoundPage />} />
      </Route>
    </Routes>
  )
}
