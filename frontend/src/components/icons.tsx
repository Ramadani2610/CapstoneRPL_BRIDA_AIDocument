// Rekonstruksi ikon dari file Figma "Project-RPL".
// Semua geometri SVG diambil apa adanya dari aset Figma, hanya warnanya
// memakai currentColor supaya bisa diatur lewat class text-*.
import type { SVGProps } from 'react'

type IconProps = SVGProps<SVGSVGElement>

function Svg({ children, ...props }: IconProps) {
  return (
    <svg
      viewBox="0 0 16 16"
      fill="none"
      stroke="currentColor"
      strokeWidth={2}
      strokeLinecap="round"
      strokeLinejoin="round"
      xmlns="http://www.w3.org/2000/svg"
      {...props}
    >
      {children}
    </svg>
  )
}

// Nav: Dashboard, Buat Pengajuan, Riwayat Status (18x18)
export function GridIcon(props: IconProps) {
  return (
    <Svg viewBox="0 0 18 18" {...props}>
      <path d="M3 2.25H6.75C7.16421 2.25 7.5 2.58579 7.5 3V8.25C7.5 8.66421 7.16421 9 6.75 9H3C2.58579 9 2.25 8.66421 2.25 8.25V3C2.25 2.58579 2.58579 2.25 3 2.25Z" />
      <path d="M11.25 2.25H15C15.4142 2.25 15.75 2.58579 15.75 3V5.25C15.75 5.66421 15.4142 6 15 6H11.25C10.8358 6 10.5 5.66421 10.5 5.25V3C10.5 2.58579 10.8358 2.25 11.25 2.25Z" />
      <path d="M11.25 9H15C15.4142 9 15.75 9.33579 15.75 9.75V15C15.75 15.4142 15.4142 15.75 15 15.75H11.25C10.8358 15.75 10.5 15.4142 10.5 15V9.75C10.5 9.33579 10.8358 9 11.25 9Z" />
      <path d="M3 12H6.75C7.16421 12 7.5 12.3358 7.5 12.75V15C7.5 15.4142 7.16421 15.75 6.75 15.75H3C2.58579 15.75 2.25 15.4142 2.25 15V12.75C2.25 12.3358 2.58579 12 3 12Z" />
    </Svg>
  )
}

export function FilePlusIcon(props: IconProps) {
  return (
    <Svg viewBox="0 0 18 18" {...props}>
      <path d="M8.5125 16.5H4.5C3.67157 16.5 3 15.8284 3 15V3C3 2.17157 3.67157 1.5 4.5 1.5H10.5C10.98 1.49882 11.4407 1.68945 11.7795 2.0295L14.4705 4.7205C14.8106 5.05933 15.0012 5.51996 15 6V10.0125" />
      <path d="M10.5 1.5V5.25C10.5 5.66421 10.8358 6 11.25 6H15" />
      <path d="M10.5 14.25H15" />
      <path d="M12.75 12V16.5" />
    </Svg>
  )
}

export function HistoryIcon(props: IconProps) {
  return (
    <Svg viewBox="0 0 18 18" {...props}>
      <path d="M2.25 9C2.25 12.7279 5.27208 15.75 9 15.75C12.7279 15.75 15.75 12.7279 15.75 9C15.75 5.27208 12.7279 2.25 9 2.25C7.11296 2.2571 5.30173 2.99342 3.945 4.305L2.25 6" />
      <path d="M2.25 2.25V6H6" />
      <path d="M9 5.25V9L12 10.5" />
    </Svg>
  )
}

// Ikon besar ikut warna induknya (bukan #6E6E6E seperti di Figma)
export function FileTextIcon(props: IconProps) {
  return (
    <Svg viewBox="0 0 18 18" {...props}>
      <path d="M8.5125 16.5H4.5C3.67157 16.5 3 15.8284 3 15V3C3 2.17157 3.67157 1.5 4.5 1.5H10.5C10.98 1.49882 11.4407 1.68945 11.7795 2.0295L14.4705 4.7205C14.8106 5.05933 15.0012 5.51996 15 6V10.0125" />
      <path d="M10.5 1.5V5.25C10.5 5.66421 10.8358 6 11.25 6H15" />
      <path d="M10.5 14.25H15" />
      <path d="M12.75 12V16.5" />
    </Svg>
  )
}

export function ShieldCheckIcon(props: IconProps) {
  return (
    <Svg viewBox="0 0 14 14" {...props}>
      <path d="M11.66 7.53006C11.66 10.4965 9.61906 11.9797 7.19326 12.84C7.06624 12.8838 6.92825 12.8817 6.80257 12.8341C4.37094 11.9797 2.33 10.4965 2.33 7.53006V3.37704C2.33 3.04937 2.59107 2.78375 2.91312 2.78375C4.07937 2.78375 5.53719 2.0718 6.55183 1.17C6.80704 0.94815 7.18296 0.94815 7.43817 1.17C8.45864 2.07773 9.91062 2.78375 11.0769 2.78375C11.3989 2.78375 11.66 3.04937 11.66 3.37704V7.53006Z" />
      <path d="M5.25 6.995L6.41667 8.16L8.75 5.83" />
    </Svg>
  )
}

export function ChevronRightIcon(props: IconProps) {
  return (
    <Svg viewBox="0 0 14 14" {...props}>
      <path d="M5.25 10.5L8.75 7L5.25 3.5" />
    </Svg>
  )
}

export function ChevronDownIcon(props: IconProps) {
  return (
    <Svg viewBox="0 0 16 16" {...props}>
      <path d="M4 6L8 10L12 6" />
    </Svg>
  )
}

export function ChevronLeftIcon(props: IconProps) {
  return (
    <Svg viewBox="0 0 16 16" {...props}>
      <path d="M10 4L6 8L10 12" />
    </Svg>
  )
}

export function BellIcon(props: IconProps) {
  return (
    <Svg viewBox="0 0 20 20" {...props}>
      <path d="M8.56 17.5C8.85808 18.0136 9.4089 18.33 10.005 18.33C10.6011 18.33 11.1519 18.0136 11.45 17.5" />
      <path d="M2.64832 12.775C2.42376 13.0188 2.3656 13.3709 2.5 13.6728C2.6344 13.9748 2.93604 14.1698 3.26921 14.17H16.7303C17.0634 14.1701 17.3652 13.9755 17.5 13.6738C17.6348 13.372 17.5771 13.0199 17.3529 12.7758C16.2339 11.6333 15.0477 10.4192 15.0477 6.67C15.0477 3.90858 12.7876 1.67 9.99975 1.67C7.21187 1.67 4.95185 3.90858 4.95185 6.67C4.95185 10.4192 3.76475 11.6333 2.64832 12.775Z" />
    </Svg>
  )
}

export function PlusIcon(props: IconProps) {
  return (
    <Svg viewBox="0 0 16 16" {...props}>
      <path d="M3.33 8H12.66" />
      <path d="M8 3.33V12.66" />
    </Svg>
  )
}

export function AlertCircleIcon(props: IconProps) {
  return (
    <Svg viewBox="0 0 20 20" {...props}>
      <path d="M1.67 10.005C1.67 5.40171 5.40171 1.67 10.005 1.67C14.6083 1.67 18.34 5.40171 18.34 10.005C18.34 14.6083 14.6083 18.34 10.005 18.34C5.40171 18.34 1.67 14.6083 1.67 10.005Z" />
      <path d="M10 6.67V10" />
      <path d="M10 13.33H10.01" />
    </Svg>
  )
}

export function ArrowRightIcon(props: IconProps) {
  return (
    <Svg viewBox="0 0 14 14" {...props}>
      <path d="M2.92 7H11.09" />
      <path d="M7 2.92L11.08 7.005L7 11.09" />
    </Svg>
  )
}

export function InfoIcon(props: IconProps) {
  return (
    <Svg viewBox="0 0 16 16" {...props}>
      <path d="M1.33 7.995C1.33 4.31402 4.31402 1.33 7.995 1.33C11.676 1.33 14.66 4.31402 14.66 7.995C14.66 11.676 11.676 14.66 7.995 14.66C4.31402 14.66 1.33 11.676 1.33 7.995Z" />
      <path d="M3.29 3.29L6.12 6.12" />
      <path d="M9.89 6.12L12.72 3.29" />
      <path d="M9.89 9.89L12.72 12.72" />
      <path d="M6.12 9.89L3.29 12.72" />
      <path d="M5.33 7.995C5.33 6.52316 6.52316 5.33 7.995 5.33C9.46684 5.33 10.66 6.52316 10.66 7.995C10.66 9.46684 9.46684 10.66 7.995 10.66C6.52316 10.66 5.33 9.46684 5.33 7.995Z" />
    </Svg>
  )
}

export function HomeIcon(props: IconProps) {
  return (
    <Svg viewBox="0 0 14 14" {...props}>
      <path d="M8.75 12.25V7.58333C8.75 7.26117 8.48883 7 8.16667 7H5.83333C5.51117 7 5.25 7.26117 5.25 7.58333V12.25" />
      <path d="M1.75 5.67185C1.74992 5.31969 1.90122 4.9854 2.16358 4.75808L6.24692 1.17C6.68173 0.793268 7.31827 0.793268 7.75308 1.17L11.8364 4.75808C12.0988 4.9854 12.2501 5.31969 12.25 5.67185V11.054C12.25 11.7145 11.7277 12.25 11.0833 12.25H2.91667C2.27233 12.25 1.75 11.7145 1.75 11.054V5.67185Z" />
    </Svg>
  )
}

export function SearchIcon(props: IconProps) {
  return (
    <Svg viewBox="0 0 16 16" {...props}>
      <path d="M14 14L11.11 11.11" />
      <path d="M2 7.335C2 4.38856 4.38856 2 7.335 2C10.2814 2 12.67 4.38856 12.67 7.335C12.67 10.2814 10.2814 12.67 7.335 12.67C4.38856 12.67 2 10.2814 2 7.335Z" />
    </Svg>
  )
}

export function EyeIcon(props: IconProps) {
  return (
    <Svg viewBox="0 0 16 16" {...props}>
      <path d="M1.33 8.22694C1.27411 8.0773 1.27411 7.9127 1.33 7.76306C2.44331 5.08039 5.07498 3.33 7.995 3.33C10.915 3.33 13.5467 5.08039 14.66 7.76306C14.7159 7.9127 14.7159 8.0773 14.66 8.22694C13.5467 10.9096 10.915 12.66 7.995 12.66C5.07498 12.66 2.44331 10.9096 1.33 8.22694Z" />
      <path d="M6 8C6 6.89543 6.89543 6 8 6C9.10457 6 10 6.89543 10 8C10 9.10457 9.10457 10 8 10C6.89543 10 6 9.10457 6 8Z" />
    </Svg>
  )
}

export function PencilIcon(props: IconProps) {
  return (
    <Svg viewBox="0 0 16 16" {...props}>
      <path d="M14.6597 4.10485C15.4259 3.33879 15.426 2.0966 14.66 1.33035C13.894 0.564094 12.6518 0.563938 11.8856 1.33L2.59734 10.6206C2.43575 10.7817 2.31625 10.9801 2.24936 11.1982L1.33 14.2271C1.29335 14.3497 1.32698 14.4826 1.41755 14.573C1.50812 14.6634 1.64102 14.6968 1.76358 14.66L4.79308 13.7413C5.01103 13.675 5.20938 13.5562 5.37072 13.3954L14.6597 4.10485Z" />
      <path d="M10 3.33L12.67 6" />
    </Svg>
  )
}

export function TrashIcon(props: IconProps) {
  return (
    <Svg viewBox="0 0 16 16" {...props}>
      <path d="M2 4.33H14" />
      <path d="M5.33 4.33V2.67C5.33 2.3 5.63 2 6 2H10C10.37 2 10.67 2.3 10.67 2.67V4.33" />
      <path d="M3.33 4.33L4 13.33C4.03 13.7 4.34 14 4.71 14H11.29C11.66 14 11.97 13.7 12 13.33L12.67 4.33" />
    </Svg>
  )
}

export function UploadCloudIcon(props: IconProps) {
  return (
    <Svg viewBox="0 0 16 16" {...props}>
      <path d="M14 11.33V12.67C14 13.4 13.4 14 12.67 14H3.33C2.6 14 2 13.4 2 12.67V11.33" />
      <path d="M4.67 6L8 2.67L11.33 6" />
      <path d="M8 2.67V10.67" />
    </Svg>
  )
}

export function CheckIcon(props: IconProps) {
  return (
    <Svg viewBox="0 0 16 16" {...props}>
      <path d="M3.33 8.33L6.5 11.5L12.67 4.67" />
    </Svg>
  )
}

export function ClipboardListIcon(props: IconProps) {
  return (
    <Svg viewBox="0 0 18 18" {...props}>
      <path d="M6.75 3H5.25C4.42157 3 3.75 3.67157 3.75 4.5V15C3.75 15.8284 4.42157 16.5 5.25 16.5H12.75C13.5784 16.5 14.25 15.8284 14.25 15V4.5C14.25 3.67157 13.5784 3 12.75 3H11.25" />
      <path d="M6.75 1.5H11.25V4.5H6.75V1.5Z" />
      <path d="M6.75 8.25H11.25" />
      <path d="M6.75 11.25H11.25" />
    </Svg>
  )
}

export function UsersIcon(props: IconProps) {
  return (
    <Svg viewBox="0 0 18 18" {...props}>
      <path d="M12 15.75V14.25C12 13.4544 11.6839 12.6913 11.1213 12.1287C10.5587 11.5661 9.79565 11.25 9 11.25H4.5C3.70435 11.25 2.94129 11.5661 2.37868 12.1287C1.81607 12.6913 1.5 13.4544 1.5 14.25V15.75" />
      <path d="M6.75 8.25C8.40685 8.25 9.75 6.90685 9.75 5.25C9.75 3.59315 8.40685 2.25 6.75 2.25C5.09315 2.25 3.75 3.59315 3.75 5.25C3.75 6.90685 5.09315 8.25 6.75 8.25Z" />
      <path d="M16.5 15.75V14.25C16.4995 13.5855 16.2783 12.9396 15.8705 12.4115C15.4627 11.8835 14.8906 11.5027 14.2425 11.3272" />
      <path d="M11.9925 2.32725C12.6423 2.50173 13.2161 2.88284 13.6249 3.41193C14.0337 3.94102 14.2547 4.58879 14.2547 5.25525C14.2547 5.92171 14.0337 6.56948 13.6249 7.09857C13.2161 7.62766 12.6423 8.00877 11.9925 8.18325" />
    </Svg>
  )
}

export function FilterIcon(props: IconProps) {
  return (
    <Svg viewBox="0 0 16 16" {...props}>
      <path d="M2 4H14" />
      <path d="M4 8H12" />
      <path d="M6.67 12H9.33" />
    </Svg>
  )
}

export function ClockIcon(props: IconProps) {
  return (
    <Svg viewBox="0 0 16 16" {...props}>
      <path d="M2 8C2 11.3137 4.68629 14 8 14C11.3137 14 14 11.3137 14 8C14 4.68629 11.3137 2 8 2C6.32263 2.00631 4.71265 2.66082 3.50667 3.82667L2 5.33333" />
      <path d="M2 2V5.33H5.33" />
      <path d="M8 4.67V8.00571L10.67 9.34" />
    </Svg>
  )
}

export function DownloadIcon(props: IconProps) {
  return (
    <Svg viewBox="0 0 16 16" {...props}>
      <path d="M2 11.33V12.67C2 13.4 2.6 14 3.33 14H12.67C13.4 14 14 13.4 14 12.67V11.33" />
      <path d="M4.67 7.33L8 10.67L11.33 7.33" />
      <path d="M8 10.67V2" />
    </Svg>
  )
}

