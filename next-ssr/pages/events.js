import useSWR from 'swr';
const fetcher = url => fetch(url).then(res => res.json());
export default function Events() {
  const { data, error } = useSWR("https://swaeduae.ae/api/events", fetcher);
  if (error) return <div>Failed to load</div>;
  if (!data) return <div>Loading...</div>;
  return (
    <main>
      <h1>Upcoming Events</h1>
      <ul>
        {data.map(ev => (
          <li key={ev.id}>{ev.name} ({ev.date})</li>
        ))}
      </ul>
    </main>
  );
}
