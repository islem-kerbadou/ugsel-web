import React, { useState, useEffect } from 'react';
import { Competition } from '../../types';
import { competitionService } from '../../services/api';
import { CompetitionCard } from './CompetitionCard';
import { CompetitionForm } from './CompetitionForm';
import { LoadingSpinner } from '../common/LoadingSpinner';
import { ErrorMessage } from '../common/ErrorMessage';
import { Button } from '../common/Button';

interface CompetitionListProps {
  sportId: number;
  sportName?: string;
}

export const CompetitionList: React.FC<CompetitionListProps> = ({ sportId, sportName }) => {
  const [competitions, setCompetitions] = useState<Competition[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);
  const [showForm, setShowForm] = useState(false);

  const fetchCompetitions = async () => {
    try {
      setLoading(true);
      setError(null);
      const data = await competitionService.getBySport(sportId);
      setCompetitions(data);
    } catch (err) {
      setError(err instanceof Error ? err.message : 'Erreur lors du chargement des compétitions');
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchCompetitions();
  }, [sportId]);

  const handleCreateCompetition = async (name: string) => {
    try {
      const newCompetition = await competitionService.create({
        name,
        sport: `/api/sports/${sportId}`,
      });
      setCompetitions((prev) => [...prev, newCompetition]);
      setShowForm(false);
    } catch (err) {
      throw err instanceof Error ? err : new Error('Erreur lors de la création');
    }
  };

  const handleDeleteCompetition = async (id: number) => {
    try {
      await competitionService.delete(id);
      setCompetitions((prev) => prev.filter((c) => c.id !== id));
    } catch (err) {
      setError(err instanceof Error ? err.message : 'Erreur lors de la suppression');
    }
  };

  if (loading) {
    return <LoadingSpinner />;
  }

  return (
    <div className="mt-3">
      <div className="d-flex justify-content-between align-items-center mb-3">
        <h5 className="mb-0">Compétitions ({competitions.length})</h5>
        {!showForm && (
          <Button size="sm" onClick={() => setShowForm(true)}>
            + Ajouter une compétition
          </Button>
        )}
      </div>

      {showForm && (
        <div className="mb-3">
          <CompetitionForm
            onSubmit={handleCreateCompetition}
            onCancel={() => setShowForm(false)}
            sportName={sportName}
          />
        </div>
      )}

      {error && <ErrorMessage message={error} onDismiss={() => setError(null)} />}

      {competitions.length === 0 && !showForm ? (
        <div className="text-center text-muted p-3">
          Aucune compétition pour ce sport.
        </div>
      ) : (
        <div>
          {competitions.map((competition) => (
            <CompetitionCard
              key={competition.id}
              competition={competition}
              onDelete={handleDeleteCompetition}
            />
          ))}
        </div>
      )}
    </div>
  );
};
