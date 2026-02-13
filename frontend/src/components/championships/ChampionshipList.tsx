import React, { useState, useEffect } from 'react';
import { Championship } from '../../types';
import { championshipService } from '../../services/api';
import { ChampionshipCard } from './ChampionshipCard';
import { ChampionshipForm } from './ChampionshipForm';
import { LoadingSpinner } from '../common/LoadingSpinner';
import { ErrorMessage } from '../common/ErrorMessage';
import { Button } from '../common/Button';

interface ChampionshipListProps {
  competitionId: number;
  competitionName?: string;
}

export const ChampionshipList: React.FC<ChampionshipListProps> = ({
  competitionId,
  competitionName,
}) => {
  const [championships, setChampionships] = useState<Championship[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);
  const [showForm, setShowForm] = useState(false);

  const fetchChampionships = async () => {
    try {
      setLoading(true);
      setError(null);
      const data = await championshipService.getByCompetition(competitionId);
      setChampionships(data);
    } catch (err) {
      setError(err instanceof Error ? err.message : 'Erreur lors du chargement des championnats');
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchChampionships();
  }, [competitionId]);

  const handleCreateChampionship = async (name: string) => {
    try {
      const newChampionship = await championshipService.create({
        name,
        competition: `/api/competitions/${competitionId}`,
      });
      setChampionships((prev) => [...prev, newChampionship]);
      setShowForm(false);
    } catch (err) {
      throw err instanceof Error ? err : new Error('Erreur lors de la création');
    }
  };

  const handleDeleteChampionship = async (id: number) => {
    try {
      await championshipService.delete(id);
      setChampionships((prev) => prev.filter((c) => c.id !== id));
    } catch (err) {
      setError(err instanceof Error ? err.message : 'Erreur lors de la suppression');
    }
  };

  if (loading) {
    return <LoadingSpinner />;
  }

  return (
    <div className="mt-2">
      <div className="d-flex justify-content-between align-items-center mb-2">
        <h6 className="mb-0">Championnats ({championships.length})</h6>
        {!showForm && (
          <Button size="sm" onClick={() => setShowForm(true)}>
            + Ajouter un championnat
          </Button>
        )}
      </div>

      {showForm && (
        <div className="mb-2">
          <ChampionshipForm
            onSubmit={handleCreateChampionship}
            onCancel={() => setShowForm(false)}
            competitionName={competitionName}
          />
        </div>
      )}

      {error && <ErrorMessage message={error} onDismiss={() => setError(null)} />}

      {championships.length === 0 && !showForm ? (
        <div className="text-center text-muted p-2 small">
          Aucun championnat pour cette compétition.
        </div>
      ) : (
        <div>
          {championships.map((championship) => (
            <ChampionshipCard
              key={championship.id}
              championship={championship}
              onDelete={handleDeleteChampionship}
            />
          ))}
        </div>
      )}
    </div>
  );
};
