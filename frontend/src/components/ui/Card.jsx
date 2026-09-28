export default function Card({ className = '', children }) {
  return (
    <div className={'rounded-xl border border-slate-200 bg-white ' + className}>
      {children}
    </div>
  )
}
